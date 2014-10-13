class UnverifiedUser < ActiveRecord::Base

	def self.insert(verification_code, phone_number, verified=false)
  		@newUnverifiedUser = UnverifiedUser.new(:verification_code => verification_code, 
  									  :phone_number => phone_number,
  									  :verified => verified)
  		@newUnverifiedUser.save
  		return @newUnverifiedUser
	end

end
