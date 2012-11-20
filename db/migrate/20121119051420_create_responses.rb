class CreateResponses < ActiveRecord::Migration
  def change
    create_table :responses do |t|
      t.string :name
      t.string :email
      t.text :content
      t.integer :package_id

      t.timestamps
    end
  end
end
