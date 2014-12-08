{% extends 'layouts/layout.volt' %}
{% block content %}
    {% if search is defined and search != '' %}
        <div class="row">
            <h4>Search results by: "{{ search }}"</h4>
        </div>
    {% endif %}
    <div class="row">
        {% for item in items %}
            <div class="col-sm-1 col-md-2" id="{{ item.getId() }}">
                <div class="thumbnail m-thumbnail">
                    {{ image('img/no-cover.jpg', 'data-original' : item.getImage(), 'class' : 'lazy img-responsive', 'width' : '300', 'height' : '300', 'alt' : item.getName()) }}
                    <div class="caption">
                        {{ link_to(item.getLink() ~ '/' ~ item.getId(), item.getName(), 'class' : 'item-title-xs text-center') }}
                    </div>
                </div>
            </div>
        {% elsefor %}
            <h4>No tires found :(</h4>
        {% endfor %}
    </div>

{% endblock %}
{% block scripts %}
    <script type="text/javascript">
        $(function () {
            $("img.lazy").lazyload({effect: "fadeIn"});
        });
    </script>
{% endblock %}