<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 1</title>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap/bootstrap.min.css') }}" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<form id="upload-form" method="post" enctype="multipart/form-data">
<div class="container">
    <div class="row it">
        {!! csrf_field() !!}
            <div class="offset-sm-1 col-sm-10" id="one">
                <p>
                Please upload documents only in 'pdf', 'docx', 'rtf', 'jpg', 'jpeg', 'png' & 'text' format.
                </p><br>
            <div class="row">
                <div class="offset-sm-4 col-sm-4 form-group">
                    <h3 class="text-center">My Documents</h3>
                </div><!--form-group-->
            </div><!--row-->
            <div id="uploader">
            <div class="row uploadDoc">
                <div class="col-sm-4 offset-sm-4">
                    <div class="docErr">Please upload valid file</div><!--error-->
                    <div class="fileUpload btn btn-orange">
                        <img src="https://image.flaticon.com/icons/svg/136/136549.svg" class="icon">
                        <span class="upl" id="upload">Upload document</span>
                        <input type="file" name="files[]" class="upload up" multiple="true"/>
                    </div><!-- btn-orange -->
                </div><!-- col-3 -->
            </div><!--row-->
            </div><!--uploader-->
            <div class="panel panel-primary" id="request_panel">
                <div class="panel-heading"><h3 class="panel-title">Selected Files</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group" id="select-list">
                    </ul>
                </div>
            </div>
            <div class="text-center">
                <button  type="submit" class="btn btn-next col-sm-4"><i class="fa fa-paper-plane"></i> Submit</button>
            </div>
            <div class="panel panel-primary" id="response_panel">
                <div class="panel-heading"><h3 class="panel-title">Recently Uploaded Files</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group"  id="uploaded-list">
                    </ul>
                </div>
            </div>
            </div><!--one-->
    </div><!-- row -->
</div><!-- container -->
</form>
<script src="{{ URL::asset('assets/js/bootstrap/jquery-3.5.1.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('input:file').change(function(){
            if(this.files.length>0){
                $('#request_panel').css("display", "block");
                $('#select-list').html('');
                for(var i = 0 ; i < this.files.length ; i++){
                    var fileName = this.files[i].name;
                    $('#select-list').append('<li class="list-group-item"><strong>'+fileName+'</li>');
                }
            }else{
                $('#request_panel').css("display", "none");
            }
        });

        $('form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax
            ({
                url: '{{ url('/') }}',
                type: 'POST',              
                data: formData,
                processData: false,
                contentType: false,
                success: function(result)
                {
                    if(result.status=="Upload Success"){
                        $('#select-list').html('');
                        $('#request_panel').css("display", "none");
                        $('#response_panel').css("display", "block");
                        result.data.forEach(file => {
                            $('#uploaded-list').append('<li class="list-group-item"><strong>'+file+'</li>');
                        });
                    }else{
                        console.log(result.status);
                        alert(result.status);
                    }
                },
                error: function(data)
                {
                    console.log(data);
                    alert(data.status);
                }
            });

        });
    });
</script>
</body>
</html>