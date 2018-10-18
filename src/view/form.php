<!DOCTYPE html>
<html lang=fr dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="dist/css/master.css">
    <title>StarUML watermark remover</title>
    <script src="dist/js/index.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="jumbotron">
                <a href="">
                    <h2 class="display-6">StarUML watermark remover</h2>
                </a>
                <div id="result"></div>
                <hr class="my-4">
                <div id="content">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group mb-4">
                            <label for="filesToUpload">Files to upload</label>
                            <input class="form-control-file" type="file" size="70" name="filesToUpload[]"
                                   id="filesToUpload" multiple="multiple"/>
                        </div>
                        <button class="btn btn-primary" type="submit" value="Upload Files" name="submit">Upload Files
                        </button>
                        <input type="hidden" name="token" id="token" value="<?php echo htmlspecialchars($token); ?>"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
