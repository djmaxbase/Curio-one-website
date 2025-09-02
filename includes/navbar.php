<header>
  <div class="container">
    <h1><a href="#home">🤖 Curio One</a></h1>
    <nav>
      <a href="#home">Home</a>
      <a href="#about">Over Ons</a>
      <a href="#robots">Robot</a>
      <a href="#blog">Blog</a>
      <a href="#sponsors">Sponsoren</a>
      <a href="#contact">Contact</a>
    </nav>
  </div>
</header>
<script>
  const header = document.querySelector("header");
  const sections = document.querySelectorAll("section");
  const navLinks = document.querySelectorAll("header nav a");

  // Shrink header on scroll
  window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }

    // Highlight active section
    let current = "";
    sections.forEach(section => {
      const sectionTop = section.offsetTop - 80;
      const sectionHeight = section.clientHeight;
      if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
        current = section.getAttribute("id");
      }
    });

    navLinks.forEach(link => {
      link.classList.remove("active");
      if (link.getAttribute("href") === "#" + current) {
        link.classList.add("active");
      }
    });
  });

  document.querySelectorAll('header nav a').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });


</script>