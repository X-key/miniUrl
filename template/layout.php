<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
    <head>
        {% block header %}
            {% include "header.php" %}
        {% endblock %}
    </head>
    <body>
        {% block body %}
            {% include "body.php" %}
        {% endblock %}
    </body>
<!--<script>
    $( '#optionsRadios3:input' ).on( 'click', function() {
        $( '#ownshortlink' ).css( "visibility","visible " );
    });
</script>-->
</html>

