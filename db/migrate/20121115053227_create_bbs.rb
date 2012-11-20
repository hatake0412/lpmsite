#encoding: utf-8
class CreateBbs < ActiveRecord::Migration
  def change
    create_table :bbs do |t|
      t.string :name, :default => '名無し'
      t.string :email
      t.text :content
      t.integer :package_id

      t.timestamps
    end
  end
end
