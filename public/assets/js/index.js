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

	// window.addEventListener('livewire:load', () => {
	// 	initializeSelectr();
	// });

	// window.addEventListener('livewire:update', () => {
	// 	const selectrElements = document.querySelectorAll('.selectr-container');
	// 	selectrElements.forEach((element) => {
	// 		const selectrInstance = element.selectr;
	// 		selectrInstance.destroy(); // destroy the previous instances of Selectr
	// 	});

	// 	initializeSelectr();
	// });

	// function initializeSelectr() {
	// 	const selectrElements = document.querySelectorAll('.selectr');
	// 	selectrElements.forEach((element) => {
	// 		new Selectr(element, {
	// 			placeholder: element.dataset.placeholder ? element.dataset.placeholder : 'Select',
	// 			allowClear: Boolean(element.dataset.allowClear),
	// 		});
	// 	});
	// }


	window.addEventListener('livewire:load', () => {
		initializeSelect2();
	});      
 

	window.addEventListener('livewire:update', () => {
		$('.select2').select2('destroy'); //destroy the previous instances of select2
		initializeSelect2();
	});

	function initializeSelect2() {

		$('.select2').each(function() {
			$(this).select2({
				theme: 'bootstrap4',
				width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
					'100%' : 'style',
				placeholder: $(this).data('placeholder') ? $(this).data('placeholder') : 'Select',
				allowClear: Boolean($(this).data('allow-clear')),
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