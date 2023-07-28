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

	window.addEventListener('switch-theme', event => {
		$("html").attr("class", `${event.detail.theme}`)
	});

	window.addEventListener('switch-header-color', event => {

		$("html").removeClass("headercolor1 headercolor2 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8");
		$("html").addClass(`color-header ${event.detail.color}`);
		
	});

	window.addEventListener('switch-sidebar-color', event => {

		$("html").removeClass("sidebarcolor1 sidebarcolor2 sidebarcolor3 sidebarcolor4 sidebarcolor5 sidebarrcolor6 sidebarcolor7 sidebarcolor8");
		$("html").addClass(`color-sidebar ${event.detail.color}`);

	});

	//SEE MORE OR LESS IMPLEMENTATION FOR LONG TEXT/PARAGRAPHS

	// get all the "see more" buttons
	const seeMoreButtons = $(".see-more");

	// add click event listener to each button
	seeMoreButtons.on("click", function() {
		// get the grand parent of the button

		const  grandParentElement= $(this).parent().parent();

		// get the summary and details paragraphs in the grand parent
		const summaryParagraph = grandParentElement.find(".summary");
		const detailsParagraph = grandParentElement.find(".details");

		// toggle the hidden class of the paragraphs
		summaryParagraph.toggleClass("d-none");
		detailsParagraph.toggleClass("d-none");

	});


});
