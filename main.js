async function getPosts() {
    let res = await fetch('http://localhost:8012/api/posts');
    let posts = await res.json();

    document.querySelector('.post-list').innerHTML = '';
    posts.forEach(post => {
        document.querySelector('.post-list').innerHTML += `
            <div class="card" style="width: 18rem">
                <div class="card-body">
                    <h5 class="carb-title">${post.title}</h5>
                    <p class="card-text">${post.body}</p>
                    <a href="http://localhost:8012/api/posts/${post.id}" class="card-link">More</a>
                    <a href="#" class="card-link" onclick="removePost(${post.id})">Remove post</a>
                </div>
            </div>`
    });
}

async function addPost() {
    const title = document.querySelector('#title').value,
        body = document.querySelector('#body').value;

    let formData = new FormData();
    formData.append('title', title);
    formData.append('body', body);

    const res = await fetch('http://localhost:8012/api/posts', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();
    if (data.status === true) {
        await getPosts();
    }
}

async function removePost(id) {

    const res = await fetch(`http://localhost:8012/api/posts/${id}`, {
        method: 'DELETE'
    });

    const data = await res.json();
    if (data.status === true) {
        await getPosts();
    }
}

