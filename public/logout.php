<?require 'includes/footer.php';?>
<script>
  fetch(apiLink+'/logout', {credentials: 'include'}).then(data => data.json())
  .then(data => {
    window.location.href='/'
  }).catch(err => console.error(err))
</script>
