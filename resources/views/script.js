fetch('header.php')
  .then(response => response.text())
  .then(data => {
    document.querySelector('header').innerHTML = data;
  });


fetch('footer.php')
  .then(response => response.text())
  .then(data => {
    document.querySelector('footer').innerHTML = data;
  });

