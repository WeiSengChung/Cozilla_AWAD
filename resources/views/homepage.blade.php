<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COZILLA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .menu-icon {
            font-size: 24px;
            cursor: pointer;
            width: 30px;
        }
        
        .search-bar {
            flex-grow: 1;
            margin: 0 20px;
            position: relative;
        }
        
        .search-bar input {
            width: 100%;
            padding: 10px 15px;
            border-radius: 25px;
            border: 1px solid #ddd;
            outline: none;
            font-size: 16px;
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        
        .carousel {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
        
        .carousel::-webkit-scrollbar {
            display: none;
        }
        
        .carousel-item {
            flex: 0 0 280px;
            margin-right: 15px;
            /* other styles */
        }
        
        .carousel-item img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        
        .testimonials {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px;
            gap: 20px;
        }
        
        .testimonial-card {
            background-color: #323d33;
            color: white;
            border-radius: 10px;
            padding: 20px;
            flex: 1 1 300px;
            display: flex;
            flex-direction: column;
        }
        
        .testimonial-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .testimonial-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }
        
        .testimonial-name {
            font-weight: bold;
            font-size: 18px;
        }
        
        .testimonial-text {
            margin-top: 10px;
            line-height: 1.4;
            font-style: italic;
        }
        
        .rating {
            color: #e2d0a8;
            margin-top: 10px;
        }
        
        @media (max-width: 768px) {
            .testimonials {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="menu-icon">≡</div>
        <div class="search-bar">
            <input type="text" placeholder="Search...">
        </div>
        <div class="logo">COZILLA</div>
    </div>
    
    <div class="carousel">
        <div class="carousel-item">
            <img src={{ asset("images/image/fashionSale.jpg") }} alt="Summer Fashion Sale">
            <div class="carousel-content">
                <h2>Summer FASHION SALE</h2>
                <p>UP TO 70% OFF</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src={{ asset("images/image/summerClassic.jpg") }} alt="Summer Classics">
            <div class="carousel-content">
                <h2>SUMMER CLASSICS</h2>
            </div>
        </div>
        <div class="carousel-item">
            <img src={{ asset("images/image/offer50.jpg") }} alt="H&M Sale">
            <div class="carousel-content">
                <h2>SALE 50% OFF</h2>
                <p>VEN YA A TU TIENDA H&M</p>
            </div>
        </div>
    </div>
    
    <div class="testimonials">
        <div class="testimonial-card">
            <div class="testimonial-header">
                <img src="../image/julia.jpg" alt="Julia" class="testimonial-avatar">
                <h3 class="testimonial-name">Julia</h3>
            </div>
            <p class="testimonial-text">"The quality of this attire is exceptional; it feels durable and well-made."</p>
            <div class="rating">★★★★☆</div>
        </div>
        
        <div class="testimonial-card">
            <div class="testimonial-header">
                <img src="/api/placeholder/40/40" alt="Amerson" class="testimonial-avatar">
                <h3 class="testimonial-name">Amerson</h3>
            </div>
            <p class="testimonial-text">"I love the design of this outfit; it's stylish and unique."</p>
            <div class="rating">★★★★★</div>
        </div>
        
        <div class="testimonial-card">
            <div class="testimonial-header">
                <img src="/api/placeholder/40/40" alt="Elicia" class="testimonial-avatar">
                <h3 class="testimonial-name">Elicia</h3>
            </div>
            <p class="testimonial-text">Confortable price and fast shipping</p>
            <div class="rating">★★★★★</div>
        </div>
    </div>

    <script>
        // Simple carousel functionality
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.querySelector('.carousel');
            const items = document.querySelectorAll('.carousel-item');
            let currentIndex = 0;
            
            function moveToNextSlide() {
                currentIndex = (currentIndex + 1) % items.length;
                carousel.scrollTo({
                    left: items[currentIndex].offsetLeft,
                    behavior: 'smooth'
                });
            }
            
            // Auto-scroll carousel every 5 seconds
            setInterval(moveToNextSlide, 5000);
        });
    </script>
</body>
</html>