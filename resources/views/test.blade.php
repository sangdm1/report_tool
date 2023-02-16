<script type="text/javascript">
    // fetch('/api/google/callback')
    fetch(`/api/google/callback${window.location.search}`)
    .then(
        function(response) {
        if (response.status !== 200) {
            console.log('Lỗi, mã lỗi ' + response.status);
            return;
        }
        // parse response data
        // console.log(response);

        response.json().then(data => {
            console.log(data);
        })
        }
    )
    .catch(err => {
        console.log('Error :-S', err)
    });
        console.log('executing js here..')
  
</script>