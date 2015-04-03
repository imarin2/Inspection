<script type="text/javascript">

	var positions = new Array();
	var ticker_url = '';
	var interval_ticker;
	var interval_temperature;
	var isMacro=false;
	var firstEntry=true;
	var showTemperatureConsole = false;
	var disableInputs = false;

	
	$(function() { 
		
		/** MOTORS */
		$("#motors").on('change', function(){
	        if ($(this).prop('checked')) {
	            motors("on");    
	        } else {
			    motors("off");         
	        }
	    });
	    
	    
	    /** COORDINATES */
	    $("#coordinates").on('change', function(){
	        if ($(this).prop('checked')) {
	            coordinates("relative");    
	        } else {
			    coordinates("absolute");         
	        }
	    });  
	    
	    
	    /** LIGHTS */
	    $("#lights").on('change', function(){
	        if ($(this).prop('checked')) {
	            lights("on");    
	        } else {
			    lights("off");         
	        }
	    });
		
		
		/** INIT  */
		<?php echo $_motors == "on" ? ' $("#motors").prop("checked", true);' : ''; ?>
    
    	<?php echo $_coordinates == "relative" ? ' $("#coordinates").prop("checked", true);' : ''; ?>
    
    	<?php echo $_lights == "on" ? ' $("#lights").prop("checked", true);' : ''; ?>
    	
    	
    	/** EVENTS */
    	$( ".axisz" ).on( "click", axisz );
    
		$(".directions").on("click", directions);
	
		$("#zero-all").on("click", zero_all);
	    
	    $("#position").on("click", position);
	    
	    $(".refresh-temperature").on("click", function() {
	    	showTemperatureConsole=true;
	    	refresh_temperature();
	    });
	    
	    $("#bed-align").on("click", bed_align);
	    
	    $('#run').on('click', mdi);
	    
	    
	    $('#save-position').on('click', save_position);
	    
	    $('.saved-position').on('click', saved_position);
	    
	    $("#home-all-axis").on('click', home_all_axis);

	    $("#act-joy").on('click', act_joy);
	    
	    
	    $("#clear-console").on('click', function(){
	    	$(".console").html('');
	    });
	    
	    
	    $("#clear-mdi").on('click', function(){
	    	$("#mdi").val('');
	    });
	
		$('.directions-container').on('keydown',function(e) {
		      keyboard(e);
		});
	     
	    $('.directions-container').on('keypress',function(e) {
		      keyboard(e);
		});
		
		/** KNOB */
		$('.knob').knob({
	        change: function (value) {
	        },
	        release: function (value) {
				rotation(value);
	        },
	        cancel: function () {
	            console.log("cancel : ", this);
	        }
		 });
		 
		 
		$('.knob').keypress(function(e) {
	        if(e.which == 13) {
	        	rotation($(this).val());
	        }
	 	 });
	 	 
	 	$('#exece-mdi').on( "click", mdi );
	 	 
	 	/** EXTRUDER TEMPERATURE */
	 	$("#ext-target-temp").noUiSlider({
	 	 	
	        range: {'min': 0, 'max' : 230},
	        start: <?php echo $_ext_temp ?>,
	        handles: 1,
            connect: 'lower'
		});
		
		$("#act-ext-temp").noUiSlider({
	 	 	
	        range: {'min': 0, 'max' : 230},
	        start: <?php echo $_ext_temp ?>,
	        handles: 0,
            connect: 'lower',
            behaviour: "none"
		});
		
		
		$("#act-ext-temp .noUi-handle").remove();
		 
		$("#ext-target-temp").on({
			slide: extTempSlide,
        	change: extTempChange
	 	});
	 	
	 	
	 	$(".extruder-range").noUiSlider_pips({
			mode: 'positions',
			values: [0,25, 50, 75, 100],
			density: 5,
			format: wNumb({
				prefix: '&deg;'
			})
		});
	 	
		
	 	
	 	/** BED TEMPERATURE */
	 	$("#bed-target-temp").noUiSlider({
	        range: {'min': 0, 'max' : 100},
	        start: <?php echo $_bed_temp ?>,
	        handles: 1,
	        connect: 'lower'
      	});
      	
      	$("#act-bed-temp").noUiSlider({
	 	 	
	        range: {'min': 0, 'max' : 100},
	        start: <?php echo $_bed_temp ?>,
	        handles: 0,
            connect: 'lower',
            behaviour: "none"
		});
      	$("#act-bed-temp .noUi-handle").remove();
      	
      	
      	$("#bed-target-temp").on({
			slide: bedTempSlide,
        	change: bedTempChange
	 	});
	 	
	 	$(".bed-range").noUiSlider_pips({
			mode: 'positions',
			values: [0,25,50,75,100],
			density: 5,
			format: wNumb({
				prefix: '&deg;'
			})
		});
	 	
	 	 
	 	
	 	
	 	$(".extruder-mode").on('click', function() {
        	if(!disableInputs){
        	$('.extruder-mode').removeClass('active');
	    	$('.mode-container').hide();
	    	$(this).addClass('active');
	    	var mode = $(this).attr("data-mode");
	    	$("#mode-" + mode ).show();
	    	extruder_mode(mode); 
	    	
	    	var mode_label = mode == "a" ? '4th axis' : 'Extruder';
	    	
	    	$(".mode").html(mode_label);
        	}  
	        
	   	});
	   	
	   	
	   	$("#mdi").keypress(function(e) {
            if(e.which == 13 && !disableInputs) {
                if(!e.shiftKey){
                  mdi(); 
                }
            }
    	});
	   	
	   	
	   	$(".extruder-e-action").on('click', function(){
        	extruder_e_action($(this).attr("data-action"));
     	});
	   	

		pre_jog();
		/** TICKER */
    	interval_ticker   = setInterval(ticker, 500);
    	
    	
    	interval_temperature = setInterval(function(){
    			if(SOCKET_CONNECTED && ticker_url == '') {
    				showTemperatureConsole=false;
    				make_call_ws("get_temperature", "");
    			}
    	}, 5000);
    	
    	
    	  	
    	
    	/** RESET CONTROLLER */
    	$("#reset-controller").on('click', ask_reset);
		
		
		$("#z-step").spinner({
				step : 0.01,
				numberFormat : "n",
				min: 0
		});
		
		
		$("#step").spinner({
				step :0.5,
				numberFormat : "n",
				min: 0
		});
		
		$("#feedrate").spinner({
				step :50,
				numberFormat : "n",
				min: 0
		});
		
		
		$("#extruder-e-value").spinner({
			step:1,
			numberFormat : "n",
			min: 0
		});
		
		
		$('.progress-bar').progressbar({
			display_text : 'fill'
		});
		

	});
	

	
	/** FUNCTIONS  */
	
	function axisz(){
    
	    var func = $(this).attr("data-attribute-function");
	    var step = $(this).attr("data-attribute-step");
	    
	    if(SOCKET_CONNECTED){
	    	make_call_ws(func, step);
	    }else{
	    	make_call(func, step);
	    }
	    
	    
	    
	}
	
	function directions(){
		var value = $(this).attr("data-attribue-direction");
		
		if(SOCKET_CONNECTED){
			make_call_ws("directions", value);
		}else{
			make_call("directions", value);
		}
	}
	
	function zero_all(){
		
		if(SOCKET_CONNECTED){
			make_call_ws("zero_all", true);
		}else{
			make_call("zero_all", true);
		}
		
	}
	
	function bed_align(e){
	    make_call("bed-align", true, true);
	}
	
	function saved_position(){
	    
	    var gcode = jQuery.trim($(this).attr("data-code"));
	    make_call('mdi', gcode);
	    
	}
	
	function home_all_axis(){
	    make_call("home_all_axis", true, true);
	}
	
	function extTempSlide(e){
		if(!disableInputs){
	    	var slide_val = parseInt($(this).val());
	    	$("#ext-degrees").html(slide_val + '&deg;C');
		}
	}
	
	function extTempChange(e){
		if(!disableInputs){
		if(SOCKET_CONNECTED){
			make_call_ws("ext_temp", parseInt($(this).val()));
		}else{
			make_call("ext_temp", parseInt($(this).val()));
		}
		}
   		
	}
	
	function bedTempSlide(e){
		if(!disableInputs){
    	var slide_val = parseInt($(this).val());
    	$("#bed-degrees").html(slide_val + '&deg;C');
		}
	}
	
	function bedTempChange(e){

		if(!disableInputs){
		if(SOCKET_CONNECTED){
			make_call_ws("bed_temp", parseInt($(this).val()));
		}else{
			make_call("bed_temp", parseInt($(this).val()));
		}
		}
		
    	
	}
	
	function mdi(){
		
		var gcode = jQuery.trim($("#mdi").val());
		jQuery("#mdi").val(gcode.replace('<br>', ''));
	    if(gcode != ''){
	    	
	    	if(SOCKET_CONNECTED){
				 make_call_ws('mdi', gcode);
			}else{
				 make_call('mdi', gcode);
			}
	    }	
	}
	
	function extruder_mode(mode){
	    
	    if(SOCKET_CONNECTED){
			 make_call_ws("extruder_mode", mode);
		}else{
			 make_call("extruder_mode", mode);
		}
	    
	}
	
	function motors(value){
		
		
		if(SOCKET_CONNECTED){
			make_call_ws("motors", value);
		}else{
			make_call("motors", value);
		}
	
	}
	
	
	function coordinates(value){
		
		make_call("coordinates", value);
	    enable_save_position();
	}
	
	
	function lights(value){

		if(SOCKET_CONNECTED){
			make_call_ws("lights", value);
		}else{
			make_call("lights", value);
		}

	}
	
	function position(){
		
		if(SOCKET_CONNECTED){
			make_call_ws("position", true);
		}else{
			make_call("position", true);
		}
		
    	
	}
	
	function rotation(value){

		
		
		if(SOCKET_CONNECTED){
			make_call_ws("rotation", value);
		}else{
			make_call("rotation", value);
		}
			
	}
	
	function extruder_e_action(action){
		
		
		if(SOCKET_CONNECTED){
			make_call_ws("extruder_e", action + $("#extruder-e-value").val());
		}else{
			make_call("extruder_e", action + $("#extruder-e-value").val());
		}
		
    	
	}
	
	
	
	function refresh_temperature(){
		
		
		if(SOCKET_CONNECTED){
			
			make_call_ws("get_temperature", "");
			
		}else{
    
		    $.ajax({ 
		    	url : '<?php echo module_url('jog').'ajax/temperature.php' ?>',
				dataType : 'json',
				type: 'post',
					  async : true,
			}).done(function(response) {
				  
		            if(response.ext != "" && response.ext != null){
		                
		                $("#ext-actual-degrees").html(parseInt(response.ext) + '&deg;C');
		                $("#ext-degrees").html(parseInt(response.ext_target) + '&deg;C');
		                
		                $("#ext-target-temp").val( parseInt(response.ext_target), {
		                	set: true,
		                	animate: true
		                });
		                	                
		                $("#act-ext-temp").val( parseInt(response.ext), {
		                	set: true,
		                	animate: true
		                });
	
		            }
		            
		            if(response.bed != "" && response.bed != null){
		                $("#bed-actual-degrees").html(parseInt(response.bed) + '&deg;C');
		                $("#bed-degrees").html(parseInt(response.bed_target) + '&deg;C');
	
		                $("#bed-target-temp").val( parseInt(response.bed_target), {
		                	set: true,
		                	animate: true
		                });
		                
		                $("#act-bed-temp").val( parseInt(response.bed), {
		                	set: true,
		                	animate: true
		                });
	
		            }
		            
		            
		            write_to_console('Temperatures (M105) [Ext: ' + parseInt(response.ext) + ' / ' + parseInt(response.ext_target)   + ' ---  Bed: ' + parseInt(response.bed) + ' / ' + parseInt(response.bed_target) +  ']\n');
		          
		        });
	        
	    }
	}
	
	
	function save_position(e){

	    $.ajax({
	        url : '<?php echo module_url('jog').'ajax/position.php' ?>',
	        dataType : 'json',
	        type: 'post',
	        async : true,
	   	}).done(function(response) {
	        
	        var coords = {'x' : response.x, 'y' : response.y, 'z': response.z};
	        
	        if(positions.length < 5){
	            positions[positions.length] = coords;
	        }else{
	            positions.shift();
	            positions.push(coords);
	        }
	        e.preventDefault();
	        set_positions();
	        
	        
	    });    
	}
	
	
	function ticker(){
		
		if(!SOCKET_CONNECTED){
		    if(ticker_url != ''){
				getTrace(ticker_url, 'GET', $(".console"));
		    }
	   }
	}
	
	
	
	
	function make_call_ws(func, value){
		
		var jsonData = {};
		
		jsonData['func']     = func;
		jsonData['value']    = value;
		jsonData['step']     = $("#step").val();
		jsonData['z_step']   = $("#z-step").val();
		jsonData['feedrate'] = $("#feedrate").val();
		
		var message = {};
		
		message['name'] = "serial";
		message['data'] = jsonData;
		
		if(func != 'get_temperature') $(".btn").addClass('disabled');
		SOCKET.send('message', JSON.stringify(message));
		
	}
	
	
	function make_call(func, value, macro){
    
    	
    	macro = macro || false;
	    var timestamp = new Date().getTime();

	    
	    if(macro){
	    	ticker_url = '/temp/macro_trace';
	    	isMacro=true;
	    }
	            
	    $(".btn").addClass('disabled');
	    $("#reset-controller").removeClass('disabled');
	    
	    $(".status").html(' <i class="fa fa-spin fa-spinner fa-2x"></i>');
	
		$.ajax({
			type: "POST",
			url : "<?php echo module_url('jog').'ajax/exec.php' ?>",
			data : {function: func, value: value, time: timestamp, step:$("#step").val(), z_step:$("#z-step").val(), feedrate: $("#feedrate").val(), macro:macro},
			dataType: "json"
		}).done(function( data ) {
			
			if(!macro){
				var separator = '-----------\n';
	        	write_to_console(separator + data.data.command + ': ' + data.data.response);
	       	}
	        
	        isMacro=false;
	        $(".btn").removeClass('disabled');
	        enable_save_position();
	        ticker_url = '';
	        $(".status").html(' ');
		});
		
	}
	
	
	function enable_save_position(){
    
	    var type = $("#coordinates").prop('checked') ? 'relative' : 'absolute';
	    
	    if(type == 'relative'){
	        $('.saved-position').addClass('disabled');
	        $("#save-position").addClass('disabled'); 
	    }else{
	        $('.saved-position').removeClass('disabled');
	        $("#save-position").removeClass('disabled');
	    }
	    
	}
	
	
	function pre_jog(){
	    
	    $(".status").html(' <i class="fa fa-spin fa-spinner fa-2x"></i>');
	    $(".btn").addClass('disabled');
	    var timestamp = new Date().getTime();        
	    /*ticker_url = 'http://<?php echo $_SERVER['HTTP_HOST'] ?>/temp/pre_jog_' + timestamp + '.trace';*/
	    ticker_url = 'http://<?php echo $_SERVER['HTTP_HOST'] ?>/temp/macro_trace';
	   
	    
	    $.ajax({
	              url : '<?php echo module_url('jog').'ajax/pre_jog.php' ?>',
				  dataType : 'json',
				  type: 'post',
	              data: {time : timestamp}
			}).done(function(response) {
			  
	             ticker_url = '';
	             refresh_temperature();
	             $(".btn").removeClass('disabled');
	             $(".status").html('');
	        });
	    
	}
		
	
	function ask_reset(){
		
		
		$.SmartMessageBox({
			title: "Reset controller",
			content: "This operation will reset your control board, continue?",
			buttons: '[No][Yes]'
			}, function(ButtonPressed) {
			   
				if (ButtonPressed === "Yes") {
				  	reset_controller();
					
				}
				if (ButtonPressed === "No") {
					
					return false;
				}
		
		});
		
		
	}
	
	function reset_controller(){
		
		
		$(".btn").addClass('disabled');
		$("#reset-controller").html('Resetting..');
	    $.ajax({
	              url : '<?php echo module_url('controller').'ajax/reset_controller.php' ?>',
				  dataType : 'json',
				  type: 'post'
			}).done(function(response) {
			 
			 	 $(".btn").removeClass('disabled');
			 	 $("#reset-controller").html('Reset controller');
			 	  write_to_console('<strong>Reset controller</strong>', '<strong>done</strong>\n');
			 	
	        });
		 
		
	}
	
	
	function update_temperature_info(data){
		
		if(data.response.indexOf('ok T:') > -1){
			
			var str_temp = data.response.replace('ok ', '');
			
			var temperature = str_temp.split(' ');

			var ext_temp = temperature[0].split(':')[1];
			var ext_target = temperature[1].split('/')[1];		
			
			var bed_temp = temperature[2].split(':')[1];
			var bed_target = temperature[3].split('/')[1];
			
			
			$("#ext-actual-degrees").html(parseInt(ext_temp) + '&deg;C');
		                	                
            $("#act-ext-temp").val( parseInt(ext_temp), {
            	set: true,
            	animate: true
            });
            
            
            $("#bed-actual-degrees").html(parseInt(bed_temp) + '&deg;C');
			 $("#act-bed-temp").val( parseInt(bed_temp), {
            	set: true,
            	animate: true
            });
			
			
			if(firstEntry){
				
				$("#ext-degrees").html(parseInt(ext_target) + '&deg;C');
				$("#bed-degrees").html(parseInt(bed_target) + '&deg;C');
				
				
				$("#ext-target-temp").val( parseInt(ext_target), {
		    		set: true,
		    		animate: true
		    	});

            	$("#bed-target-temp").val( parseInt(bed_target), {
            		set: true,
            		animate: true
            	});
            	firstEntry = false;
           	}
			
			if(showTemperatureConsole){
				write_to_console('Temperatures (M105) [Ext: ' + parseInt(ext_temp) + ' / ' + parseInt(ext_target)   + ' ---  Bed: ' + parseInt(bed_temp) + ' / ' + parseInt(bed_target) +  ']\n');	
			}
			
			
				
		}
		
	}
	
	
	function write_to_console(text, type) {

		type = type || '';
	
		if (type == 'macro' || type == "task") {
			$('.console').html(text);
		} else {
			$('.console').append(text);
		}
	
		$('.console').scrollTop(1E10);
		waitContent(text);
		
		$(".btn").removeClass('disabled');
	}

    function act_joy() {
//         var act_joy_button = $("#act-joy");
        $("#act-joy").text("Joystick Control Activated");
        $(".btn").addClass('disabled'); 
//         $(".noUiSlider").addClass('disabled');
        disableInputs = true;
        var now = jQuery.now();
        ticker_url = '/temp/inspection_console';

        $.ajax({
                type: "POST",
                url: "/fabui/application/plugins/inspection/ajax/startjog.php",
                data: {
                    time: now
                },
                dataType: "html"
            }).done(function(data) {
            	$("#act-joy").text("Activate joystick");
            	$(".btn").removeClass('disabled');
//             	$(".noUiSlider").removeClass('disabled');
            	disableInputs = false;
            	ticker_url = '';
            });
    }
	
	
</script>