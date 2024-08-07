<html>
<head>
  <title>Laravel Crud</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- A grey horizontal navbar that becomes vertical on small screens -->
    <!-- A grey horizontal navbar that becomes vertical on small screens -->
    <nav class="navbar navbar-expand-sm bg-dark">

<!-- Links -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="/">Products</a>
  </li>
 
</ul>

</nav>
  <div class="container">
   <div class="row justify-content-center">
    <div class="col-sm-8">
      <div class="card mt-3 p-3">
      <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="">Name</label>
          <input type="text" name="name" class="form-control"/>
        </div>

        <div class="form-group">
          <label for="">Description</label>
         <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
          <label for="">Image</label>
         <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-dark">Submit</button>

      </form>
      </div>

    </div>

   </div>
  </div>


</body>


</html>