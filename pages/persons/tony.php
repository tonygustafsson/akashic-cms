[template: default]
[data: test]

<h1>Tony Gustafsson</h1>

<p>The creator of this ${name} CMS!</p>

[foreach ${persons}:
	<li>
		<strong>${name}</strong> is ${age} years old and is working as a ${occupation}.
	</li>
]

<p>
	<a href="[link: start]">Back</a>
</p>
