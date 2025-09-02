<section id="about">
  <div class="container">
    <div class="left"></div>
    <div class="right">
      <h2>Over Ons</h2>
      <p>Wij zijn Curio One: een enthousiaste groep van 15 studenten van Curio in Nederland.  
         Ons doel is leren, ontdekken en groeien in technologie en teamwork.  
         Binnenkort vind je hier meer informatie en foto’s van ons team!</p>
      <a href="#contact" class="learn-more">Meld je aan >></a>
    </div>
  </div>
</section>
<script>
  const aboutRight = document.querySelector('#about .right');
  const h2 = aboutRight.querySelector('h2');
  const p = aboutRight.querySelector('p');
  const button = aboutRight.querySelector('a.learn-more');

  function handleScroll() {
    const rect = aboutRight.getBoundingClientRect();
    const windowHeight = window.innerHeight || document.documentElement.clientHeight;

    if (rect.top <= windowHeight * 0.75) {
      h2.classList.add('slide-in');
      p.classList.add('slide-in');
      button.classList.add('slide-in');
      window.removeEventListener('scroll', handleScroll); 
    }
  }

  window.addEventListener('scroll', handleScroll);

</script>