require 'twilio-ruby'

class SmsresponderController < ApplicationController

	before_filter :initialize

	def initialize
		puts 'Initializing';

	end

	def main
	    twiml = Twilio::TwiML::Response.new do |r|
	        r.Message do |message|
	        	message.Body "Hey Monkey. Thanks for the message!"
	        end
	    end
	    render :xml => twiml.text
	end

end
