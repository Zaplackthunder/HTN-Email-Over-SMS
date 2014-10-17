class User < ActiveRecord::Base

	def self.insert(phone_number, email, access_token, refresh_token)
  		@newuser = User.new(:access_token => access_token, 
                       	 	:phone_number => phone_number,
                        	:refresh_token => refresh_token,
                        	:email => email)
  		@newuser.save
	end

end
