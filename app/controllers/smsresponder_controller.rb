require 'twilio-ruby'
require 'email_client'

class SmsresponderController < ApplicationController

	before_filter :initialize
	@email_client = nil

	def initialize
		puts 'Initializing';
		@email_client = EmailClient.new
	end

	def main
		user = User.find_by( :phone_number => params['From'].to_s )
		if user != nil then
		else
			unverified_user = UnverifiedUser.find_by( :phone_number => params['From'].to_s )
			if unverified_user != nil then
			else
			end
		end
		
		messages = @email_client.getMessageList(user, Time.now - 7*24*60*60)

	    twiml = Twilio::TwiML::Response.new do |r|
	        r.Message do |message|
	        	message.Body messages.to_s
	        end
	    end

	    render :xml => twiml.text
	end

end
