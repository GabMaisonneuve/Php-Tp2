{{ include('layouts/header.php', { title: 'Create Post' }) }}

<a class="button-link" href="{{ base }}/list_posts">View All Posts</a>

<div class="container">
    <form action="{{ base }}/posts/create" method="POST">
        <h1>Create a new Post</h1>
        {% if errors %}
    <ul class="errors">
        {% for error in errors %}
            <li>{{ error }}</li>
        {% endfor %}
    </ul>
{% endif %}
        <label for="title">Title:
            <input type="text" id="title" name="title" required>
        </label>
        <label>Content:
            <textarea name="content" required></textarea>
        </label>
        <label for="category_id">Category:
            <select name="category_id" id="category_id" required>
                <option value="">Select a category</option>
                {% for cat in categories %}
                    <option value="{{ cat.id }}">{{ cat.name }}</option>
                {% endfor %}
            </select>
        </label>
        <label>Image URL (optional)
            <input type="text" name="image">
        </label>
        <input type="submit" value="Create Post">

        {% if message %}
            <div class="message">{{ message }}</div>
        {% endif %}
    </form>
</div>
