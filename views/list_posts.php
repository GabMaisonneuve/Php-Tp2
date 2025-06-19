{{ include('layouts/header.php', { title: 'Create Post' }) }}
    <a class="button-link" href="{{ base }}/home">Create a Post</a>
    <h1>All Posts</h1>

     {% for p in posts %} 
       <article>
        <h2> {{p.title}} </h2>
        <p>By {{p.author}} | Category:  {{p.category}} </p>
        <p>  {{p.content}} </p>
       <a href="{{ base }}/posts/delete?id={{ p.id }}" class="button-link">Delete</a>
        <a href="{{ base }}/edit_post?id={{ p.id }}" class="button-link">Edit</a>
       </article>

     {% endfor %} 
