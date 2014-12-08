{% extends 'layouts/layout.volt' %}
{% block content %}
    <div class="col-lg-12">
        <h3>{{ object.getName() }}</h3>
        <div class="col-sm-7">
            {{ image('img/p/' ~ object.getId() ~ '.jpg') }}
        </div>
        <div class="col-sm-5">
            <h4>Pret {{ object.getPrice() }} Lei</h4>
            <p><button type="button" class="btn btn-large btn-primary">Adauga in cos</button> </p>
        </div>
    </div>
    <div class="col-sm-12">
        <h4>Descriere</h4>
        <p class="text-muted">{{ object.getDescription() }}</p>
    </div>
{% endblock %}