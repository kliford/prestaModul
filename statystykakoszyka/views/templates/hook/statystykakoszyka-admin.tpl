<section class="container container-modul-admin">
    <div class="row top-section">
        <div class="col">
            <h2>Wybierz jakie dane potrzebujesz</h2>
            <div class="lead">
                Wybierz jakie dane mają być pokazane w bloki "Podsumowanie"
            </div>
        </div>
    </div>
    <form action="" method="post">
        <div class="row top-middle checkbox-bl mt-3">
            <div class="btn-group col">
                <input type="checkbox" id="checkboxOrder" value="" checked>
                <label for="checkboxOrder">Pokazywać ilość zamówień</label>
            </div>
            <div class="btn-group col">
                <input type="checkbox" id="checkboxTotal" value="" checked>
                <label for="checkboxTotal">Pokazywać kwotę zamówień</label>
            </div>
        
            <div class="btn-group col">
                <input type="checkbox" id="checkboxBasket" value="" checked>
                <label for="checkboxBasket">Pokazywać ilość koszyków</label>
            </div>
            <div class="btn-group col">
                <input type="checkbox" id="checkboxClients" value="" checked>
                <label for="checkboxClients">Pokazywać ilość klientów</label>
            </div>
        </div>
        <div class="row top-bottom">
            <button type="button" class="btn btn-info btn-updateInfo">Zapisz ustawienia</button>
        </div>
    </form>
</section>