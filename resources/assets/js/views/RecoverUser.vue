<template>
	<div>
		<Navbar
			:settings="Navbar"
		/>
		<div class="col-xl-2 offset-xl-5 col-lg-2 offset-lg-5 col-md-6 offset-md-3" id="main-content">
			<h3>
				<i class="fa fa-unlock"></i>
				Account recovery
			</h3>
			<form autocomplete="off" @submit.prevent="recoverUser(user)" method="post">
				<div class="form-group">
			    	<label for="pwInput">Password</label>
			    	<input type="password" class="form-control" placeholder="Create new password" v-model="user.password" id="pwInput" name="password">
			  	</div>
			  	<div class="form-group">
			    	<label for="pwcInput">Password confirmation</label>
			    	<input type="password" class="form-control" placeholder="Confirm password" v-model="user.password_confirmation" id="pwcInput">
			  	</div>
			  	<button class="btn btn-block btn-success" @click="recoverUser(user)" :disabled="isLoading === true">
					<i class="fa fa-spinner fa-spin" v-if="isLoading === true"></i>
					RECOVER ACCOUNT
				</button>
			</form>
		</div>
	</div>
</template>
<script>
	import Navbar from '../components/shared/Navbar.vue'
	export default { 
		props: [
			'token'
		],
		components: { 
			Navbar
		},
		data () { 
			return { 
				Navbar: { 
					web: 1, 
					app: 0
				},
				isLoading: false,
				user: { 
					password: '', 
					password_confirmation: '' 
				}, 
				errors: [], 
				images: [ 
					'/images/bg1.png', 
					'/images/bg2.png', 
					'/images/bg3.png'
				]
			}
		}, 
		methods: { 
			recoverUser (user) { 
				const app = this
				axios.post(`/api/user/forgot-password/reset/${app.token}`, {
					password: user.password,
					password_confirmation: user.password_confirmation
				})
				.then((response) => { 
					console.log(response.data)
				})
			},
			cycleImage () {
                const image = this.images[Math.floor(Math.random() * this.images.length)]
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
	
	/* main content styling */
	#main-content { 
		margin-top: 30vh;
	}

	#main-content  .form-group { 
		margin-top: 8px !important;
	}

	#main-content .btn { 
		margin-top: 10px !important;
	}

	#main-content label { 
		color: #fff !important;
	}

	#main-content > h3 { 
		color: #fff;
		font-weight: 300;
		text-align: center;
	}

	#main-content h3 > i { 
		font-size: 1.75rem;
		padding-right: 5px !important;
	}

	#main-content .btn { 
		font-weight: 500;
		letter-spacing: 0.5px;
	}

	/* iphone 4/4s - portrait */
	@media only screen 
  	and (min-device-width: 320px) 
  	and (max-device-width: 480px)
  	and (-webkit-min-device-pixel-ratio: 2)
  	and (orientation: portrait) {
  		#main-content h1 { 
  			font-size: 22px;
  		}
	}

	/* iphone 5/5s/5c - portrait */
	@media only screen 
	and (min-device-width: 320px) 
	and (max-device-width: 568px)
	and (-webkit-min-device-pixel-ratio: 2)
	and (orientation: portrait) {

	}

	/* iphone 6/7 - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 667px) 
	and (-webkit-min-device-pixel-ratio: 2) { 

	}

	/* iphone 6+/7+/8+ - portrait */
	@media only screen 
	and (min-device-width: 414px) 
	and (max-device-width: 736px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 
		#main-content h1 { 
  			font-size: 28px;
  		}
	}

	/* iphone x - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 812px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 
		#main-content h1 { 
  			font-size: 28px;
  		}
	}

</style>
