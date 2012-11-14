class CreatePackages < ActiveRecord::Migration
  def change
    create_table :packages do |t|
      t.string :name
      t.string :ver
      t.text :description
      t.text :note
      t.string :depends
      t.string :cnt

      t.timestamps
    end
  end
end
