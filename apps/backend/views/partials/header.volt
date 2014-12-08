<div class="header">
    <div class="navigation-wrapper">
        <div class="navigation clearfix-normal">
            <div class="menu-main-container">
                <ul id="menu-main" class="nav">
                    <li class="menu-item menu-item-type-custom menu-item-object-custom">
                        {% if this.view.getControllerName() == 'product' %}
                            {{ link_to('product', 'class' : 'active', 'Produse') }}
                        {% else %}
                            {{ link_to('product', 'Produse') }}
                        {% endif %}
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom">
                        {% if this.view.getControllerName() == 'index' %}
                            {{ link_to('', 'class' : 'active', 'Home') }}
                        {% else %}
                            {{ link_to('', 'Home') }}
                        {% endif %}
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.navigation -->
    </div>
    <h3 class="text-muted">Netex Shop Management<span style="width: 10px; display: inline-block;"></span>
        <a href="/admin/../" class="head-shortcuts" target="_blank">Vezi site</a></h3>
</div>