class WelcomeController < ApplicationController

  def index
  end

  def create_unverified_user
    session[:phone_number] = params[:user]['phone_number']
    session[:verification_code] = "";
    for i in 0..4 
      session[:verification_code] += (1+rand(9)).to_s
    end

    UnverifiedUser.insert(session[:verification_code], session[:phone_number], false)

    render :json => {:verification_code => session[:verification_code]}, :status => :ok
  end

  def verify
    unverified_user = UnverifiedUser.find_by( :phone_number => session[:phone_number] )
    if unverified_user.verification_code == params[:verification_code] then
      unverified_user.update(:verified => true)
      render :plain => "Success", :status => :ok
    else
      render :plain => "Failure", :status => :bad_request
    end
  end

  def create_user
    access_token = request.env["omniauth.auth"]['credentials']['token'];
    refresh_token = request.env["omniauth.auth"]['credentials']['refresh_token'];
    email = request.env["omniauth.auth"]['info']['email'];
    phone_number = session[:phone_number]

    unverified_user = UnverifiedUser.find_by( :phone_number => phone_number )
    if unverified_user.verified then
      unverified_user.destroy
      User.insert(phone_number, email, access_token, refresh_token)
      render :plain => 'You have been successfull registered', :status => :ok
    else
      render :plain => 'Unable to register', :status => :bad_request
    end

  end

end

