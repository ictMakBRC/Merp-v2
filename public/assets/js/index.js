$(function() {
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




});

document.addEventListener('livewire:load', function () {
	var selectElements1 = document.querySelectorAll('.select2');    
	selectElements1.forEach(function (selectElement) {
		new Selectr(selectElement, {
			searchable: true,
			width: '200px',
		});
	});
	Livewire.hook('message.processed', function (message, component) {
		var selectElements = document.querySelectorAll('.select2');

		selectElements.forEach(function (selectElement) {
			new Selectr(selectElement, {
				searchable: true,
				width: '200px',
			});
		});
	});
});
