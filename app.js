const posts = [
	{	title: 'post one', body: 'bla-bla'},
	{	title: 'post two', body: 'bla-bla-bla'}
];

function createPost(post) {
	return new Promise(function (resolve,reject) {
		setTimeout (function () {
		posts.push(post);
		const error = false;
		if (!error) {
			resolve();
		} else {
			reject('wrong');
		}
		resolve();
		}, 2000);	
	})

}

function getPosts() {
	setTimeout(function () {
		let output = '';
		posts.forEach(function (post) {
			output += `<li>${post.title}</li>`;
		});
		document.body.innerHTML = output;
	});
}
createPost({title: 'POst Three', body: 'this is third'}).then(getPosts)
.catch(function (err) {
	console.log(err);
});
// getPosts();