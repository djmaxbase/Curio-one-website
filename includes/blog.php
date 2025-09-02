<!-- Blog Section -->
<section id="blog">
  <div class="container">
    <h2>Blog & Updates</h2>
    <div class="owl-carousel" id="blog-slider"></div>
  </div>
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
  async function loadBlog() {
    try {
      const response = await fetch("data/blog.json");
      const posts = await response.json();

      const blogSlider = document.getElementById("blog-slider");


      let html = posts
        .sort((a, b) => b.id - a.id) 
        .map(post => {
          const hasImage = !!post.image;

          if (hasImage) {
            return `
              <div class="blog-post">
                <div class="left">
                  <h3>${post.title}</h3>
                  <small>${post.time}</small>
                  <p>${post.text}</p>
                </div>
                <div class="right">
                  <img src="data/blog_img/${post.image}" alt="Blog image">
                </div>
              </div>
            `;
          } else {
            return `
              <div class="blog-post no-image">
                <h3>${post.title}</h3>
                <small>${post.time}</small>
                <p>${post.text}</p>
              </div>
            `;
          }
        })
        .join("");


      blogSlider.innerHTML = html;

      $("#blog-slider").owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        margin: 100,
        stagePadding: 200,    
        navText: [
          "<span class='prev'>&#10094;</span>", 
          "<span class='next'>&#10095;</span>"
        ],
        responsive: {
          0: {
            items: 1,
            stagePadding: 0   
          },
          768: {
            items: 1,
            stagePadding: 20
          },
          1200: {
            items: 1,
            stagePadding: 100
          }
        }
      });

    } catch (error) {
      console.error("Kon blog.json niet laden:", error);
    }
  }

  loadBlog();
</script>
