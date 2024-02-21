<footer class="mt-4 text-center">
    <hr>
    <p>CRUD de Funkos - <a href="https://www.madirex.com/" target="_blank">Madirex</a></p>
    <p>&copy; <?php echo date('Y'); ?> Madirex. Todos los derechos reservados.</p>
    @if(session()->has('username'))
        Visitas durante esta sesión: {{ session('visits') }}
    @endif
</footer>
