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
    email = request.env["omniauth.auth"]['info']['email'];
    phonenumber = session[:phonenumber]

    User.insert(access_token, refresh_token, phonenumber, email)

    render :plain => 'Thank you!'

  end

end

