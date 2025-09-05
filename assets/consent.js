(function(){
	function ready(fn){ if(document.readyState !== 'loading'){ fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }

	function setCookie(name, value, days){
		var expires = '';
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days*24*60*60*1000));
			expires = '; expires=' + date.toUTCString();
		}
		document.cookie = name + '=' + encodeURIComponent(value) + expires + '; path=/; SameSite=Lax';
	}
	function getCookie(name){
		var nameEQ = name + '=';
		var ca = document.cookie.split(';');
		for(var i=0;i<ca.length;i++){
			var c = ca[i];
			while(c.charAt(0)==' ') c = c.substring(1,c.length);
			if(c.indexOf(nameEQ) == 0) return decodeURIComponent(c.substring(nameEQ.length,c.length));
		}
		return null;
	}
	function eraseCookie(name){ setCookie(name, '', -1); }

	function createModal(){
		var overlay = document.createElement('div');
		overlay.id = 'consent-overlay';
		overlay.innerHTML = ''+
			'<div class="consent-backdrop"></div>'+
			'<div class="consent-modal" role="dialog" aria-modal="true" aria-labelledby="consent-title">'+
				'<div class="consent-content">'+
					'<h2 id="consent-title">Privacy & Cookies</h2>'+
					'<p>Cookies are necessary for this website to function properly, for performance measurement, and to provide you with the best experience.</p>'+
					'<p>By continuing to access or use this site, you acknowledge and consent to our use of cookies in accordance with our <a href="' + (window.BASE_URL || '') + 'terms.php">Terms & Conditions</a> and <a href="' + (window.BASE_URL || '') + 'privacy.php">Privacy Statement</a>.</p>'+
					'<div class="consent-actions">'+
						'<button id="consent-accept" class="btn btn-primary">Accept</button>'+
						'<button id="consent-decline" class="btn btn-secondary">Decline</button>'+
						'<button id="consent-reset" class="btn">Reset Choice</button>'+
					'</div>'+
				'</div>'+
			'</div>';
		document.body.appendChild(overlay);
		return overlay;
	}

	function ensureManageButton(){
		if(document.getElementById('consent-manage-btn')) return;
		var btn = document.createElement('button');
		btn.id = 'consent-manage-btn';
		btn.className = 'consent-manage-btn';
		btn.type = 'button';
		btn.textContent = 'Manage Cookie Consent';
		document.body.appendChild(btn);
	}

	function showModal(){
		if(!document.getElementById('consent-overlay')){ createModal(); }
		document.body.classList.add('no-scroll');
		document.getElementById('consent-overlay').style.display = 'block';
	}
	function hideModal(){
		document.body.classList.remove('no-scroll');
		var el = document.getElementById('consent-overlay');
		if(el){ el.style.display = 'none'; }
	}

	async function recordAcceptance(){
		try{
			var res = await fetch((window.BASE_URL || '') + 'consent_api.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ action: 'accept' }) });
			if(!res.ok){ throw new Error('Network error'); }
			var data = await res.json();
			if(data.status === 'ok'){
				var payload = { guid: data.guid, consent_time: data.consent_time, version: data.version };
				setCookie('site_consent', JSON.stringify(payload), 365);
			}
		}catch(e){ console.error('Failed to record consent', e); }
	}

	ready(function(){
		ensureManageButton();
		var consentCookie = getCookie('site_consent');
		var declineCookie = getCookie('site_decline');
		if(!consentCookie && !declineCookie){ showModal(); }

		document.addEventListener('click', function(e){
			if(e.target && e.target.id === 'consent-accept'){
				// If user accepts, clear decline cookie if set
				if(getCookie('site_decline')){ eraseCookie('site_decline'); }
				recordAcceptance();
				hideModal();
				return;
			}
			if(e.target && e.target.id === 'consent-decline'){
				// If user declines, clear consent cookie if set
				if(getCookie('site_consent')){ eraseCookie('site_consent'); }
				setCookie('site_decline', new Date().toISOString(), 1);
				hideModal();
				return;
			}
			if(e.target && e.target.id === 'consent-reset'){
				eraseCookie('site_consent');
				eraseCookie('site_decline');
				showModal();
				return;
			}
			if(e.target && e.target.id === 'consent-manage-btn'){
				showModal();
				return;
			}
		});
	});
})();
