<style>
body {
    background-color: #fffdf7;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-image: url('/ComaContento/imagenes/fondo.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    position: relative;
}

body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.7);
    z-index: -1;
}

.navbar {
    background: linear-gradient(to right, #fcd116, #003893, #ce1126);
        border-bottom-left-radius: 1rem;
        border-bottom-right-radius: 1rem;
}
.navbar-brand, .nav-link, footer {
    color: white !important;
    font-weight: 600;
}
.hero {
    background-size: cover;
    background-position: center;
    color: black;
    padding: 7rem 2rem;
    text-align: center;
    background-blend-mode: overlay;
    background-color: rgba(0, 0, 0, 0);
    border-radius: 0 0 2rem 2rem;
}
.hero h1 {
    font-size: 3.5rem;
    font-weight: bold;
}
.hero p {
    font-size: 1.2rem;
}
.section-title {
    font-weight: bold;
    font-size: 2rem;
    margin-bottom: 2rem;
}
.card {
    border: none;
    border-radius: 1.5rem;
    overflow: hidden;
    background-color: #fff;
    transition: transform 0.3s, box-shadow 0.3s;
}
.card:hover {
    box-shadow: 0 0 25px rgba(0,0,0,0.1);
    transform: translateY(-5px);
}
.card img {
    height: 180px;
    object-fit: cover;
    border-bottom: 5px solid #fcd116;
}
.btn-primary, .btn-warning, .btn-danger {
    border-radius: 50px;
    padding: 0.5rem 1.5rem;
}
footer {
    background-color: #003893;
    text-align: center;
    padding: 1.5rem;
    border-top-left-radius: 2rem;
    border-top-right-radius: 2rem;
    margin-top: 3rem;
}
</style>