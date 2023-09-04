$(function () {
	//TOASTS AND SWEET ALERTS
	window.addEventListener('alert', event => {

		if (event.detail.type == 'success') {
			iziToast.success({
				title: 'Success!',
				message: `${event.detail.message}`,
				timeout: 5000,
				position: 'topRight'
			});
		}

		if (event.detail.type == 'Error') {
			iziToast.error({
				title: 'Error!',
				message: `${event.detail.message}`,
				timeout: 5000,
				position: 'topRight'
			});
		}

		if (event.detail.type == 'warning') {
			iziToast.warning({
				title: 'Warning!',
				message: `${event.detail.message}`,
				timeout: 5000,
				position: 'topRight'
			});
		}
	});

	window.addEventListener('swal:modal', event => {
		swal({
			title: event.detail.message,
			text: event.detail.text,
			icon: event.detail.type,
		});
	});

	window.addEventListener('swal:confirm', event => {
		swal({
			title: event.detail.message,
			text: event.detail.text,
			icon: event.detail.type,
			buttons: true,
			dangerMode: true,
		})
			.then((willDelete) => {
				if (willDelete) {
					window.livewire.emit('remove');
				} else {
					window.livewire.emit('cancel');
				}
			});
	});

	window.addEventListener('livewire:load', () => {
		initializeSelectr();
	});

	window.addEventListener('livewire:update', () => {
		const selectrElements = document.querySelectorAll('.selectr-container');
		selectrElements.forEach((element) => {
			const selectrInstance = element.selectr;
			selectrInstance.destroy(); // destroy the previous instances of Selectr
		});

		initializeSelectr();
	});

	function initializeSelectr() {
		const selectrElements = document.querySelectorAll('.selectr');
		selectrElements.forEach((element) => {
			new Selectr(element, {
				placeholder: element.dataset.placeholder ? element.dataset.placeholder : 'Select',
				allowClear: Boolean(element.dataset.allowClear),
			});
		});
	}



});


function formatAmount(input) {
	var value = input.value.replace(/,/g, ''); // Remove existing commas

	// Remove non-numeric and non-decimal characters
	value = value.replace(/[^0-9.]/g, '');

	// Ensure there's only one decimal point
	var parts = value.split('.');
	if (parts.length > 2) {
		value = parts[0] + '.' + parts.slice(1).join('');
	}

	var formattedValue = addCommasToNumber(value);

	input.value = formattedValue;
}

function addCommasToNumber(value) {
	return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}