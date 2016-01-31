<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-4 col-md-4 col-md-offset-4">
                {% block content %}
                    {% include "content1.php" %}
                {% endblock %}
            </div>
        </div>
    </div>
</div>
{% block footer %}
{% include "footer.php" %}
{% endblock %}


