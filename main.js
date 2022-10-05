async function getPosts() {
    let res = await fetch('https://jsonplaceholder.typicode.com/posts');
    let posts = await res.json();

    posts.forEach(post => {
        document.querySelector('.post-list').innerHTML += `
            <div class="card" style="width: 18rem">
                <div class="card-body">
                    <h5 class="carb-title">${post.title}</h5>
                    <p class="card-text">${post.body}</p>
                    <a href="https://jsonplaceholder.typicode.com/posts/${post.id}" class="card-link">learn more...</a>
                </div>
            </div>`
    });
}

getPosts();
