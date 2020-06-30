<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script src="/js/script.js"></script>
<?
$js = isset($js) ? $js : '';
if (is_array($js)) {
  foreach ($js as $script) {
    echo "<script src='/js/$script'></script>";
  }
} else {
  echo "<script src='/js/$js'></script>";
}
?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();
    var sidenav = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(sidenav, {edge:'right'});
  });
</script>
</body>
</html>
