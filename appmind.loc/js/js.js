//     var len1=document.getElementById('days');

//     len1.oninput = function(){

//     for(i;i<len2;i++)
//     {
//     	var len2=len1.value;
//     	var i=0;
//         var el= new Array();;
//         el[i]=document.createElement('input');
//         el[i].type='text';
//         el[i].name='text'+i;
//         el[i].size = 60;
//         document.to_create.appendChild(el[i]);
//         var mybr=document.createElement('br');    
//         document.to_create.appendChild(mybr);
//     }
// }
	var id_postfix=1;
	var parm = 0;
	// var j = $('#days').on('input', function() {
	// 	var input = $('#days').val()-i;
	// 	// Add(input, i);
	// });

	function Add()
	{

		if (id_postfix <= 0) {}else{
			 var item = '<div class="field column is-4 block" id="days_i" style="display:inline-block;"><div class="control items_install"><input id="item_' + id_postfix + '" class="input huyol" type="text" placeholder="'+id_postfix+'"  name="amount_days[]" > </div>'
			 $("#i_days").append(item);
		}
     /*собачим плагин*/
  	   // $("#my_id_"+id_postfix).autocomplete();
     
     /*подготавливаем для следующего добавления*/
     // parm = $('#days').val()-parm;
   	  id_postfix++;
	}

$(function() {
$("#days").on('input',function () {
	var input = $('#days').val()-parm;
	$(".block").remove();
	if (input<=90 && input >= 10) {
		id_postfix = -parm;
		
		for (var i = 0; i < parm; i++) {
		}

		for (var i = 0; i < input+1; i++) {
			Add();
		}
	}else if (input < 10) {
		id_postfix = 1;
		for (var i = 0; i < input; i++) {
			
			Add();
		}
	}else{
		alert("Максимально кол-во дней: 90");
		}

		$('.huyol, #input_install').on('input', function() {
			var day_inst = 0;
				$('.items_install input').each(function(){
					var s = '';
					s = parseInt($(this).val());
					if (isNaN(s)) {
						day_inst += 0;
					}else{
						day_inst += parseInt($(this).val());
					}
				});
				var input_install =  (parseInt($('#input_install').val()));
				if (isNaN(input_install)) {
						input_install = 0;
					}else{
						input_install = (parseInt($('#input_install').val()))
					}
				$('#counter span').remove();
				$('#counter').append('<span> Осталось неучтённых установок: ' + (input_install - day_inst) + '</span>');
				// alert(isNaN(parseInt($('#input_install').val()) - day_inst));
			});



});
});