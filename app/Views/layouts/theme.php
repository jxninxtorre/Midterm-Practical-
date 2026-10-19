<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
<style>
:root {
    --pink: #ff8fc2;
    --pink-dark: #f06aa8;
    --pink-soft: #ffd6e8;
    --pink-bg: #fff4f9;
    --blue: #a8d8ff;
    --lav: #e3d6ff;
    --mint: #c9f2df;
    --ink: #6b4a5e;
    --ink-soft: #a68a99;
}
body {
    font-family: 'Quicksand', sans-serif;
    color: var(--ink);
    background-color: var(--pink-bg);
    background-image:
        radial-gradient(var(--pink-soft) 2px, transparent 2px),
        radial-gradient(var(--blue) 1.5px, transparent 1.5px);
    background-size: 28px 28px, 28px 28px;
    background-position: 0 0, 14px 14px;
}
h1, h2, h3, h4, h5, .navbar-brand { font-family: 'Fredoka', sans-serif; color: var(--ink); }

.kawaii-nav {
    background: linear-gradient(90deg, #ffc2dd, #d9c8ff, #b9e0ff);
    border-bottom: 4px dotted #fff;
    box-shadow: 0 4px 14px rgba(255, 143, 194, .35);
}
.kawaii-nav .navbar-brand,
.kawaii-nav .nav-link,
.kawaii-nav .navbar-text { color: var(--ink) !important; font-weight: 700; }
.kawaii-nav .nav-link:hover { color: #fff !important; text-shadow: 0 1px 0 var(--pink); }

.card {
    border: 3px solid #fff;
    border-radius: 24px;
    background: rgba(255, 255, 255, .92);
    box-shadow: 0 8px 24px rgba(255, 143, 194, .28);
}

.btn { border-radius: 999px; font-weight: 700; padding: .45rem 1.2rem; }
.btn-kawaii, .btn-dark, .btn-primary {
    background: var(--pink); color: #fff; border: 2px solid #fff;
    box-shadow: 0 4px 0 var(--pink-dark);
}
.btn-kawaii:hover, .btn-dark:hover, .btn-primary:hover {
    background: #ff74b4; color: #fff; transform: translateY(1px);
    box-shadow: 0 3px 0 var(--pink-dark);
}
.btn-secondary { background: var(--lav); border: 2px solid #fff; color: var(--ink); }
.btn-danger    { background: #ff9fb8; border: 2px solid #fff; color: #fff; }
.btn-success   { background: #8fd9b8; border: 2px solid #fff; color: #fff; }
.btn-warning   { background: #ffe29a; border: 2px solid #fff; color: var(--ink); }

.form-control, .form-select { border-radius: 16px; border: 2px solid var(--pink-soft); }
.form-control:focus, .form-select:focus {
    border-color: var(--pink);
    box-shadow: 0 0 0 .25rem rgba(255, 143, 194, .25);
}
.form-label { font-weight: 700; }

.alert { border-radius: 18px; border: 2px dashed; font-weight: 600; }
.alert-success { background: var(--mint); border-color: #8fd9b8; color: #2f6b52; }
.alert-danger  { background: #ffe0e8; border-color: #ff9fb8; color: #9b3050; }

.table { background: #fff; border-radius: 18px; overflow: hidden; }
.table thead th { background: var(--pink-soft); color: var(--ink); border: none; }
.table-hover tbody tr:hover { background: #fff0f7; }

.kawaii-footer { text-align: center; color: var(--ink-soft); padding: 1rem 0 2rem; font-weight: 600; }
</style>