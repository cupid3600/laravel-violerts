<template>
	<div>
		<Navbar
			:settings="Navbar"
		/>
		<div class="col-xl-2 offset-xl-5 col-lg-2 offset-lg-5 col-md-6 offset-md-3" id="main-content">
			<h3>
				<i class="fa fa-user"></i>
				Sign In
			</h3>
			<div class="alert alert-danger" v-if="error">
	            <p>There was an error, unable to sign in with those credentials.</p>
	        </div>
	        <div class="alert alert-info" v-if="query === 'verified'">
	            <p>
	            	The email address linked to this account is successfully 
	            	verified. You can now sign in.
	            </p>
	        </div>
	        <div class="alert alert-brand" v-if="query === 'expired'">
	            <p>
	            	The email address linked to this account is already 
	            	verified.
	            </p>
	        </div>
	        <form autocomplete="off" @submit.prevent="signIn" method="post">
	            <div class="form-group">
	                <label for="email">E-mail</label>
	                <input type="email" id="email" class="form-control" placeholder="Email" v-model="email" required>
	            </div>
	            <div class="form-group">
	                <label for="password">Password</label>
	                <input type="password" id="password" class="form-control" v-model="password" required placeholder="Password">
	            </div>
	            <button type="submit" class="btn btn-block btn-success" :disabled="isLoading == true">
	            	<i class="fa fa-spinner fa-spin" v-if="isLoading == true"></i>
	            	Sign in
	            </button>
	        </form>
		  	<router-link to="/forgot-password">Forgot your password?</router-link>
		</div>
	</div>
</template>
<script>
	import Navbar from '../components/shared/Navbar.vue'
	export default { 
		props: [ 
			'query'
		],
		components: { 
			Navbar
		},
		data () { 
			return { 
				email: null,
		        password: null,
		        error: false,
				isLoading: false,
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
			signIn () { 
				var app = this
				app.isLoading = true
		        this.$auth.login({
		            params: {
		              email: app.email,
		              password: app.password
		            }, 
		            success () {},
		            error () {
		            	app.error = true
		            	app.isLoading = false

		            },
		            rememberMe: true,
		            redirect: '/dashboard',
		            fetchUser: true,
		        });
			},
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
	.alert p { 
		margin-bottom: 0 !important;
	}
	
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
		font-weight: 500 !important;
	}

	#main-content > h3 { 
		color: #fff;
		font-weight: 300;
		text-align: center;
		margin-bottom: 10px;
	}

	#main-content h3 > i { 
		font-size: 1.75rem;
		padding-right: 5px !important;
	}

	#main-content .btn { 
		font-weight: 500;
		letter-spacing: 0.5px;
		margin-bottom: 10px !important;
	}

	#main-content a, #main-content a:hover { 
		color: #fff !important;
		text-decoration: none !important;
		font-weight: 600 !important;
		text-align: center !important;
		margin-top: 15px !important;
	}

	#main-content .alert ul { 
		padding-left: 0 !important; 
		margin-bottom: 0 !important;
		list-style: none !important;
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