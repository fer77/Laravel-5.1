<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>{{ $post->title }}</h1>

	@can('update-post', $post)
	<a href="#">update this post</a>
	@endcan
</body>
</html>