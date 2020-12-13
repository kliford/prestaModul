<section class="container-modul-page">
        <div class="row sectionPage">
            <div class="col">
                <h2 class="title-h2">{l s='Podsumowanie' mod='statystykakoszyka'}</h2>
                <div class="row contentPage justify-content-md-center">
                    <div class="inline-bl basket-bl {if $order_value != 0}active-bl{else}hide-bl{/if}">
                        <figure>
                            <img src="{$base_dir}modules/statystykakoszyka/images/img-basket.png" alt="" />   
                        </figure>
                        <div class='info-text'>
                            <p class="description-txt">{l s='Dziś złożono' mod='statystykakoszyka'}</p>
                            <p class="top-span"><span class="number-span">{$new_order}</span> {l s='zamówień' mod='statystykakoszyka'}</p>
                        </div>
                    </div>
                    <div class="inline-bl total-info-bl line-left {if $total_value != 0}active-bl{else}hide-bl{/if}">
                        <div class='info-text'>
                            <p class="description-txt txt-big"> {l s='Na kwotę' mod='statystykakoszyka'}</p>
                            <p class="top-span"><span class="number-span-paid">{$new_total_paid}</span> {$currency_shop}</p>
                        </div>
                    </div>
                    <div class="inline-bl quantity-bl line-left {if $basket_value != 0}active-bl{else}hide-bl{/if}">
                        <figure>
                            <img src="{$base_dir}modules/statystykakoszyka/images/img-bascket-sun.png" alt>
                        </figure>
                        <div class='info-text'>
                            <p class="description-txt">{l s='Dziś utworzono' mod='statystykakoszyka'}</p>
                            <p class="top-span"><span class="number-span">{$new_cart}</span> {l s='koszyków' mod='statystykakoszyka'}</p>
                        </div>
                    </div>
                    <div class="inline-bl client-bl line-left {if $client_value != 0}active-bl{else}hide-bl{/if}">
                        <figure>
                            <img src="{$base_dir}modules/statystykakoszyka/images/img-user.png" alt>
                        </figure>
                        <div class='info-text'>
                            <p class="top-span data_value"><span class="number-span">{$new_customer}</span> {l s='nowych klientów' mod='statystykakoszyka'}</p>
                            <p class="description-txt">{l s='się dziś zarejestrowało' mod='statystykakoszyka'}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>