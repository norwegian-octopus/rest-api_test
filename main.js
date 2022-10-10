async function getPosts() {
    let res = await fetch('http://localhost:8012/api/posts');
    let posts = await res.json();

    document.querySelector('.post-list').innerHTML = '';
    posts.forEach(post => {
        document.querySelector('.post-list').innerHTML += `
            <div class="card" id="post-${post.id}" style="width: 18rem">
                <div class="card-body">
                    <h5 class="card-title">${post.title}</h5>
                    <p class="card-text">${post.body}</p>
                    <a href="http://localhost:8012/api/posts/${post.id}" class="card-link">More</a>
                    <a href="#" class="card-link" onclick="removePost(${post.id})">Remove</a>
                    <a href="#" class="card-link" onclick="editPost(${post.id}, '${post.title}', '${post.body}')">Edit</a>
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

async function editPost(id, title, body) {

    document.querySelector(`#post-${id}`).innerHTML = `
            <div class="card-body">
                <input type="text" class="form-control" id="title-edit-${id}" aria-describedby="emailHelp" value="${title}">
                <textarea class="form-control" id="body-edit-${id}">${body}</textarea>
                <a href="#" class="card-link" onclick="updatePost(${id})">Update</a>
            </div>`;
}

async function updatePost(id) {
    const title = document.querySelector(`#title-edit-${id}`).value,
            body = document.querySelector(`#body-edit-${id}`).value;
    
    const data = {
        title: title,
        body: body
    };
    const res = await fetch(`http://localhost:8012/api/posts/${id}`, {
        method: 'PATCH',
        body: JSON.stringify(data)
    });

    const resData = await res.json();
    if (resData.status === true) {
        await getPosts();
    }

}

