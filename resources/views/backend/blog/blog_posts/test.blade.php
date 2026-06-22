

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


  <textarea id="tt" class="from-control">



    <div class="container">
      <div class="row">
          <div class="col-lg-12">
              <label for="requ" class="form-label">Long Description</label>
              <textarea name="long_description" id="long_description" class="form-control rounded-3 shadow-none"
                  rows="10"></textarea>
              <span class="text-danger error-text long_description_error"></span>
          </div>
      </div>
  </div>
  
  <!-- Initialize SummerNote on the textarea -->
  <script>
      $(document).ready(function () {
          $('#long_description').summernote({
              height: 300, // You can adjust the height as needed
              placeholder: 'Enter your long description here...',
              toolbar: [
                  ['style', ['bold', 'italic', 'underline', 'clear']],
                  ['font', ['strikethrough', 'superscript', 'subscript']],
                  ['para', ['ul', 'ol', 'paragraph']],
                  ['height', ['height']]
              ]
          });
      });
  </script>


  </textarea>
  <script>
    $(document).ready(function() {
        $('#tt').summernote();
    });
  </script>


