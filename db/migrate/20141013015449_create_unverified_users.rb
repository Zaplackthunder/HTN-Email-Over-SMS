class CreateUnverifiedUsers < ActiveRecord::Migration
  def change
    create_table :unverified_users do |t|
    	t.string :verification_code
    	t.string :phone_number
    	t.boolean :verified
    	t.timestamps
    end
  end
end
