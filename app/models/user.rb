class User < ActiveRecord::Base

	def self.insert(access_token, refresh_token, phonenumber, email)
  		@newuser = User.new(:access_token => access_token, 
                       	 	:phonenumber => phonenumber,
                        	:refresh_token => refresh_token,
                        	:email => email)
  		@newuser.save
	end

end
