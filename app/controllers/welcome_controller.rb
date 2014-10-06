class WelcomeController < ApplicationController
  def index
  end

  def store_phonenumber
  	session[:phonenumber] = params[:user]['phonenumber']
  	redirect_to '/auth/google_oauth2'
  end

  def create

    access_token = request.env["omniauth.auth"]['credentials']['token'];
    refresh_token = request.env["omniauth.auth"]['credentials']['refresh_token'];
    email = access_token = request.env["omniauth.auth"]['info']['email'];

  	@newuser = User.new(:access_token => access_token, 
                        :phonenumber => session[:phonenumber],
                        :refresh_token => refresh_token,
                        :email => email)
    @newuser.save
  	render :plain => 'Thank you!'
  end

end

