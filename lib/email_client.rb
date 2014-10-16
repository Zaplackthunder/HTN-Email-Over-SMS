require 'net/http'
require 'json'

class EmailClient

	@@GOOGLE_REFRESH_TOKEN_URL = "https://accounts.google.com/o/oauth2/token"

	# Return a list of all message ids no older than oldest_allowed
	# model - map - should contain fields email, access_token, refresh_token, updated_at
	# oldest_allowed - timestamp
	def getMessageList(model, oldest_allowed)
		sanitize_access_tokens(model)
		return ['test']
	end

	def getMessage(model, id)
		sanitize_access_tokens(model)
		return {'test' => 'test'}
	end

	# to do, put this into an oauth client class
	def sanitize_access_tokens(model)
          model_timestamp = model.updated_at
		if ( Time.now.to_i - model_timestamp.to_i > 3600 ) then
                        begin 
                          response = post_https_request(@@GOOGLE_REFRESH_TOKEN_URL, {
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
