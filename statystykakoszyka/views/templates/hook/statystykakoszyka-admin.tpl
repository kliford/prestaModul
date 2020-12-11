<section class="container container-modul-admin">
    <div class="row top-section">
        <div class="col">
            <h2>{l s='Wybierz jakie dane potrzebujesz ' mod='statystykakoszyka'}</h2>
            <div class="lead">
                {l s='Wybierz jakie dane mają być pokazane w bloki "Podsumowanie"' mod='statystykakoszyka'}
            </div>
        </div>
    </div>
    <form action="" method="post">
        <div class="row top-middle checkbox-bl mt-3">
            <div class="btn-group col">
                <input type="checkbox" id="checkboxOrder" value="" checked>
                <label for="checkboxOrder">{l s='Pokazywać ilość zamówień' mod='statystykakoszyka'}</label>
            </div>
            <div class="btn-group col">
                <input type="checkbox" id="checkboxTotal" value="" checked>
                <label for="checkboxTotal">{l s='Pokazywać kwotę zamówień' mod='statystykakoszyka'}</label>
            </div>
        
            <div class="btn-group col">
                <input type="checkbox" id="checkboxBasket" value="" checked>
                <label for="checkboxBasket">{l s='Pokazywać ilość koszyków' mod='statystykakoszyka'}</label>
            </div>
            <div class="btn-group col">
                <input type="checkbox" id="checkboxClients" value="" checked>
                <label for="checkboxClients">{l s='Pokazywać ilość klientów' mod='statystykakoszyka'}</label>
            </div>
        </div>
        <div class="row top-bottom">
            <button type="button" class="btn btn-info btn-updateInfo">{l s='Zapisz ustawienia' mod='statystykakoszyka'}</button>
        </div>
    </form>
</section>