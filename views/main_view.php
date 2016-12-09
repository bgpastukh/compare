<form action="" method="get">
    <input type="button" value="Check" id="check">
    <input type="button" value="Load" id="load">
</form>

<?php if (is_string($data)){ ?>

<h3><?= $data ?></h3>

<?php } elseif ($data){
    foreach ($data as $line){
        echo $line."<br>";
    }
} ?>

<script>
    document.getElementById('load').addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            document.location.href = '/compare/main/load';
        }
    });
    document.getElementById('check').addEventListener('click', function(e) {
            document.location.href = '/compare/main/check';
    });
</script>
