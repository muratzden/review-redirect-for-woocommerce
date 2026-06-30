(function () {
	'use strict';

	function ready(callback) {
		if (document.readyState !== 'loading') {
			callback();
			return;
		}

		document.addEventListener('DOMContentLoaded', callback);
	}

	ready(function () {
		var popup = document.querySelector('[data-rrfw-popup]');

		if (!popup || typeof rrfwFrontend === 'undefined') {
			return;	
		}

		var dialog = popup.querySelector('.rrfw-popup__dialog');
		var states = popup.querySelectorAll('[data-rrfw-state]');
		var feedback = popup.querySelector('[data-rrfw-feedback]');
		var ratingInput = popup.querySelector('[data-rrfw-selected-rating]');
		var response = popup.querySelector('[data-rrfw-response]');
		var successMessage = popup.querySelector('[data-rrfw-success-message]');
		var errorMessage = popup.querySelector('[data-rrfw-error-message]');
		var stars = popup.querySelectorAll('[data-rrfw-rating]');
		var googleButton = popup.querySelector('[data-rrfw-google-link]');
		var messageField = feedback ? feedback.querySelector('textarea[name="message"]') : null;
		var submitButton = feedback ? feedback.querySelector('button[type="submit"]') : null;
		var orderId = popup.getAttribute('data-rrfw-order-id');
		var storageKey = (rrfwFrontend.storageKeyPrefix || 'rrfw_review_prompt_done_') + orderId;
		var focusableSelector = 'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])';
		var closeTimer = null;

		if (!dialog || !states.length || !feedback || !ratingInput || !response || !successMessage || !errorMessage || !messageField || !submitButton || !stars.length || !orderId) {
			return;
		}

		function markDone() {
			try {
				window.localStorage.setItem(storageKey, '1');
			} catch (error) {
				return false;
			}

			return true;
		}

		function isDone() {
			try {
				return window.localStorage.getItem(storageKey) === '1';
			} catch (error) {
				return false;
			}
		}

		function getServerMessage(data, fallback) {
			if (data && data.data && data.data.message) {
				return data.data.message;
			}

			return fallback;
		}

		function getFocusableElements() {
			return Array.prototype.slice.call(dialog.querySelectorAll(focusableSelector)).filter(function (element) {
				return element.offsetParent !== null;
			});
		}

		function focusDialog() {
			var focusableElements = getFocusableElements();

			if (focusableElements.length) {
				focusableElements[0].focus();
				return;
			}

			dialog.focus();
		}

		function showState(name) {
			states.forEach(function (state) {
				state.hidden = state.getAttribute('data-rrfw-state') !== name;
			});

			window.requestAnimationFrame(focusDialog);
		}

		function closePopup() {
			window.clearTimeout(closeTimer);
			popup.classList.remove('is-open');
			popup.classList.add('is-closing');

			closeTimer = window.setTimeout(function () {
				popup.hidden = true;
				popup.classList.remove('is-closing');
			}, 220);
		}

		function handleKeydown(event) {
			var focusableElements;
			var firstElement;
			var lastElement;

			if (popup.hidden) {
				return;
			}

			if (event.key === 'Escape') {
				event.preventDefault();
				closePopup();
				return;
			}

			if (event.key !== 'Tab') {
				return;
			}

			focusableElements = getFocusableElements();

			if (!focusableElements.length) {
				event.preventDefault();
				dialog.focus();
				return;
			}

			firstElement = focusableElements[0];
			lastElement = focusableElements[focusableElements.length - 1];

			if (event.shiftKey && document.activeElement === firstElement) {
				event.preventDefault();
				lastElement.focus();
			} else if (!event.shiftKey && document.activeElement === lastElement) {
				event.preventDefault();
				firstElement.focus();
			}
		}

		if (isDone()) {
			return;
		}

		popup.hidden = false;
		showState('rating');
		window.requestAnimationFrame(function () {
			popup.classList.add('is-open');
		});

		popup.querySelectorAll('[data-rrfw-close]').forEach(function (element) {
			element.addEventListener('click', closePopup);
		});

		popup.querySelectorAll('[data-rrfw-state-target]').forEach(function (element) {
			element.addEventListener('click', function () {
				showState(element.getAttribute('data-rrfw-state-target'));
			});
		});

		document.addEventListener('keydown', handleKeydown);

		stars.forEach(function (star) {
			star.addEventListener('click', function () {
				var rating = parseInt(star.getAttribute('data-rrfw-rating'), 10);

				if (!rating || rating < 1 || rating > 5) {
					return;
				}

				ratingInput.value = rating;
				response.textContent = '';

				stars.forEach(function (item) {
					var itemRating = parseInt(item.getAttribute('data-rrfw-rating'), 10);
					var isActive = itemRating <= rating;
					item.classList.toggle('is-active', isActive);
					item.setAttribute('aria-checked', itemRating === rating ? 'true' : 'false');
				});

				if (rating >= parseInt(rrfwFrontend.threshold, 10)) {
					showState('google');
					return;
				}

				showState('feedback');
			});
		});

		if (googleButton) {
			googleButton.addEventListener('click', function () {
				markDone();
				successMessage.textContent = rrfwFrontend.googleSuccess;
				showState('success');
				window.setTimeout(closePopup, 2000);
			});
		}

		feedback.addEventListener('submit', function (event) {
			event.preventDefault();

			var message = messageField.value.trim();

			if (!message) {
				response.textContent = rrfwFrontend.feedbackError;
				messageField.focus();
				return;
			}

			submitButton.disabled = true;
			response.textContent = '';
			showState('loading');

			var formData = new FormData(feedback);
			formData.append('action', 'rrfw_submit_feedback');
			formData.append('nonce', rrfwFrontend.nonce);

			fetch(rrfwFrontend.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				body: formData
			})
				.then(function (reply) {
					return reply.json();
				})
				.then(function (data) {
					if (data && data.success) {
						successMessage.textContent = rrfwFrontend.feedbackSuccess;
						markDone();
						showState('success');
						return;
					}

					submitButton.disabled = false;
					errorMessage.textContent = getServerMessage(data, rrfwFrontend.feedbackFail);
					showState('error');
				})
				.catch(function () {
					submitButton.disabled = false;
					errorMessage.textContent = rrfwFrontend.feedbackFail;
					showState('error');
				});
		});
	});
}());