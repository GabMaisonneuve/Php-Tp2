{{ include('layouts/header.php', { title: 'Create Post' }) }}

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <a class="button-link" href="{{ base }}/home">Create a Post</a>
 <a class="button-link" href="{{ base }}/list_posts">View All Posts</a>
    <div class="container">
        <form action="{{ base }}/list_posts" method="POST">
            <input type="hidden" name="id" value="{{ existingPost.id }}">
            <h1>Edit Post</h1>
            {% if errors %}
    <ul class="errors">
        {% for error in errors %}
            <li>{{ error }}</li>
        {% endfor %}
    </ul>
{% endif %}
            <label>Title:
                <input type="text" name="title" value=" {{existingPost.title}} " required>
            </label>
            <label>Content:
                <textarea name="content" required> {{existingPost.content}}</textarea>

            </label>
      <label for="category_id">Category:
    <select name="category_id" id="category_id">
        <option value="">Select a category</option>
        {% for cat in categories %} 
            <option value="{{ cat.id }}" 
                {% if existingPost.category_id == cat.id %}selected{% endif %}>
                {{ cat.name }}
            </option>
        {% endfor %}
    </select>
</label>

<label>Image URL:
    <input type="text" name="image" value="{{ existingPost.image }}">
</label>

<input type="submit" value="Update Post">

        </form>
    </div>
</body>
</html>