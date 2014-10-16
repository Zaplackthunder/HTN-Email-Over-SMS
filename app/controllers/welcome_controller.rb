require 'twilio-ruby'

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

    # TODO: put into twilio client class and make it a singleton
    account_sid = ENV['TWILIO_ACCOUNT_SID']
    auth_token = ENV['TWILIO_AUTH_TOKEN']
    begin
        client = Twilio::REST::Client.new account_sid, auth_token
        client.account.messages.create(
          from => ENV['TWILIO_PHONE_NUMBER'],
          to => session[:phone_number],
          body => "Thanks for signing up with Dodo! Please enter the pin " + session[:verification_code] + " to get started. If you did not register, please ignore this message."
        )
    rescue Twilio::REST::RequestError => e
        puts e.message
    end

    render :json => {}, :status => :ok

  end

  def verify
    unverified_user = UnverifiedUser.find_by( :phone_number => session[:phone_number] )
    if unverified_user.verification_code == params[:verification_code] then
      unverified_user.update(:verified => true)
      redirect_to '/auth/google_oauth2'
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

