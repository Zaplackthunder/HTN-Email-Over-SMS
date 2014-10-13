class CreateUsers < ActiveRecord::Migration
  def change
    create_table :users do |u|
    	u.string :phone_number
    	u.string :email
    	u.string :access_token
    	u.string :refresh_token
    	u.timestamps
    end
  end
end
