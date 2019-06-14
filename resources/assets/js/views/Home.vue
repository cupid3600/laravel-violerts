<template>
	<div>
		<Navbar 
			:settings="Navbar"
		/>
		<Content />
	</div>
</template>
<script>
	import Navbar from '../components/shared/Navbar.vue'
	import Content from '../components/shared/Content.vue'
	export default { 
		components: { 
			Navbar, 
			Content
		},
		data () { 
			return { 
				Navbar: { 
					web: 1, 
					app: 0
				},
				images: [ 
					'/images/bg1.png', 
					'/images/bg2.png', 
					'/images/bg3.png'
				]
			}
		}, 
		methods: { 
			cycleImage () { 
				var image = this.images[Math.floor(Math.random() * this.images.length)]
				document.body.style.backgroundSize = 'cover'
				document.body.style.backgroundImage = `url('${image}')`
			}
		}, 
		mounted () { 
			this.cycleImage()
		}
	}
</script>
<style scoped>
	body::after { 
		opacity: 0.5 !important;
	}
</style>