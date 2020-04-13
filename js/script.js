$(document).ready(function(){

	var tache = $('.tache'), form = $('#form'),
	checkAll = $('#checkAll'), del = $('.del'), deleteForm = $('#deleteForm');


	$(checkAll).on('click', function(){
		if(this.checked){
			$(del).each(function(){
				this.checked = true;
			});
		}
		else{
			$(del).each(function(){
				this.checked = false;
			});
		}
	});

	$(deleteForm).on('submit', function(e){
		e.preventDefault();
		$('.alert').remove();
		var data = $(this).serialize();
		$.ajax({
			type: 'post',
			url: $(this).attr('action'),
			data: data,
			dataType: 'json',
			success: function(response){
				if(response.success){
					$('input:checked').parent().parent().fadeOut();
					$(deleteForm).before('<div class="alert alert-danger">'+response.message+'</div>');
				}
			}
		});
	});


	$(tache).each(function(){
		$(this).on('click', function(){
			$(this).attr('contenteditable', true);
		});
		$(this).on('blur', function(){
			$(this).removeAttr('contenteditable');
			var task = $(this).text();
			id = $(this).closest('tr').attr('id');
			$.ajax({
				type: 'post',
				url: 'update.php',
				data: {id: id, task: task},
				dataType: 'json',
				success: function(response){
					if(response.success){
						console.log('updated');
					}
				}
			});
		});
	});


	$(form).on('submit', function(e){
		e.preventDefault();
		var data = $(this).serialize();
		url = $(this).attr('action');
		$.ajax({
			type: 'post',
			url: url,
			data: data,
			dataType: 'json',
			success: function(response){
				console.log(response);
				if(response.success){
					$('tbody').prepend('<tr id="'+response.id+'"><td class="tache">'+response.task+'</td><td><input type="checkbox" id="'+response.id+'" class="del" name="task[]" value="'+response.id+'"></td><tr>');
					$('#task').val('');
				}
			}
		});
	});
	
});


