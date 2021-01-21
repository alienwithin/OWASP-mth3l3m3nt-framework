$(function () {
toggleFields();
 function toggleFields() {
    if ($("#means").val() == "POST")
        $("#postData").show();
    else
        $("#postData").hide();
};
//tooltips
 $('[data-toggle="tooltip"]').tooltip(); 

	//form headers
	var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".custom_headers"); //Fields wrapper
    var add_button      = $(".add_headers_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" class="form-control" name="myHeaders[]"/><a href="#" class="remove_header">Remove</a><input type="text" class="form-control" name="myHeadersValue[]"/><a href="#" class="remove_header">Remove</a></div>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_header", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
    //end form headers
    //tabs initialize
    $(function() {
        $( "#tabs" ).tabs();
    });
    //tabs initialize
    //post data toggle
    $("#means").change(function () {
        toggleFields();
    });

    //init tabs
    $( "#tabs" ).tabs();
    //end tab init
   
    //end post data toggle
    //tooltips
    $('[data-toggle="tooltip"]').tooltip();
    //end tooltips
    
    // datepicker
    $('.datepicker').datepicker({
        format: dp_format,
        weekStart: 1
    });

    // tag multiselect and auto-complete
    if($("#input-tags").length > 0) {

        varTags = $('<textarea />').html($("#input-tags").attr('data-value')).text();
        var tags = $("#input-tags").tagsManager({
            tagsContainer: '#taglist',
            prefilled: varTags.split(',')
        });

        $("#input-tags").typeahead({
            name: 'tags',
            limit: 150,
            prefetch: {
                url:'tag',
                ttl: 0
            }
        }).on('typeahead:selected', function (e, d) {
            tags.tagsManager("pushTag", d.value);
        });
    }


    // tooltips
    $('.bs-tooltip, [data-toggle="tooltip"]').tooltip();


    // editor
    if ($('#blog-text').length > 0) {
        $('#blog-text').summernote({
            height: 450
        });
        $('#post-form').on('submit', function () {
            $('#input-text').val($('#blog-text').code());
        });
    }
	
	
   

    // file upload
    if($('#fileupload').length > 0) {
        $('#fileupload').fileupload({
            url: 'cnc/file',
            dataType: 'json',
            done: function (e, data) {
//                console.log(data);
                if ("error" in data._response.result) {
                    alert(data._response.result.error);
                } else {
                    for (file in data._response.result) {
                        if(data._response.result[file] == true) {
                            $('#post-image').remove();
                            var image = $('<img id="post-image" src="'+file+'" class="thumbnail" />');
                            image.hide().slideDown();
                            $('#upload-btn').before(image);
                            $('#input-image').val(file);
                        } else {
                            alert('Error uploading file.')
                        }
                        break;
                    }
                }
            }
        });
    }

});

