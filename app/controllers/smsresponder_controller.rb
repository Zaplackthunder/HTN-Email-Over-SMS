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
		message = "Hello, World! Please type in 'get' to see a sample."

		user = User.find_by( :phone_number => params['From'].to_s )
		# TODO: Verify that twilio is the caller
		if user == nil then
			message = "You must first register to use this app!"
		else
			sanitize_access_tokens(user)
			request_uri = ''
			request_params = ''
			body = params['Body'].downcase
			if body == 'get' then # assign defaults
				puts 'assigning defaults'
				request_uri = 'https://www.googleapis.com/gmail/v1/users/' + user.email + '/messages'
				request_params = {
					'maxResults' => 1,
                                        'access_token' => user.access_token
				}
                                response = get_https_request(request_uri, request_params)
                                message = response.body

			else # parse body as JSON, get uri and params
			end	
		end
            twimlText = formTwimlResponse( message )
	    render :xml => twimlText
	end

### Helpers below

	# to do, put this into an oauth client class
	def sanitize_access_tokens(model)
		# TODO: catch if tokens revoked
		google_refresh_token_url = "https://accounts.google.com/o/oauth2/token"
                model_timestamp = model.updated_at
		if ( Time.now.to_i - model_timestamp.to_i > 3600 ) then
                        begin 
                          response = post_https_request(google_refresh_token_url, {
				'client_id' => ENV['GOOGLE_CLIENT_ID'],
				'client_secret' => ENV['GOOGLE_CLIENT_SECRET'],
				'refresh_token' => model.refresh_token,
				'grant_type' => 'refresh_token'
                                                        })
                          response.value # should raise error if http status not 2xx
                          response_body = JSON.parse(response.body)
                          model.update(:access_token => response_body['access_token'])
                        rescue Exception => e
                          puts 'Something went wrong refreshing tokens'
                          puts e.message
                          puts e.backtrace.inspect
                        end
		else 
			puts "tokens good"
		end
	end

	def formTwimlResponse ( textBody )
	    twiml = Twilio::TwiML::Response.new do |r|
	        r.Message do |message|
	        	message.Body textBody.to_s
	        end
	    end
	    return twiml.text
	end

	# Posts form to uri via https
	def get_https_request (uri, params)
		uri = URI.parse(uri)
                uri.query = URI.encode_www_form(params)
		http = Net::HTTP.new(uri.host, uri.port)
		http.use_ssl = true
		http.verify_mode = OpenSSL::SSL::VERIFY_NONE
                http.set_debug_output($stdout)

		request = Net::HTTP::Get.new(uri.request_uri)

		response = http.request(request)
		return response
	end


	# Posts form to uri via https
	def post_https_request (uri, params)
		uri = URI.parse(uri)
		http = Net::HTTP.new(uri.host, uri.port)
		http.use_ssl = true
		http.verify_mode = OpenSSL::SSL::VERIFY_NONE
                http.set_debug_output($stdout)

		request = Net::HTTP::Post.new(uri.request_uri)
		request.set_form_data(params)

		response = http.request(request)
		return response
	end


end
